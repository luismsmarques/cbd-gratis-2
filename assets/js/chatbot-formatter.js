/**
 * Shared Markdown Formatter for Chatbots
 * 
 * Converts markdown-style text to HTML for better readability
 * Used by all chatbot components in the theme
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

window.CBDChatbotFormatter = {
  /**
   * Format markdown text to HTML
   * 
   * @param {string} text - Text with markdown formatting
   * @returns {string} HTML formatted text
   */
  format: function(text) {
    if (!text || typeof text !== 'string') {
      return '';
    }
    
    let formatted = text;
    
    // Escape HTML first to prevent XSS
    const div = document.createElement('div');
    div.textContent = formatted;
    formatted = div.innerHTML;
    
    // Split into lines for processing
    const lines = formatted.split('\n');
    const result = [];
    let inList = false;
    let listType = null;
    let listItems = [];
    
    for (let i = 0; i < lines.length; i++) {
      const line = lines[i].trim();
      
      if (!line) {
        // Empty line - close list if open
        if (inList) {
          const tag = listType === 'ol' ? 'ol' : 'ul';
          result.push(`<${tag} class="message-list">${listItems.join('')}</${tag}>`);
          listItems = [];
          inList = false;
          listType = null;
        }
        continue;
      }
      
      // Check for numbered list: 1. item
      const numberedMatch = line.match(/^(\d+)\.\s+(.+)$/);
      if (numberedMatch) {
        if (!inList || listType !== 'ol') {
          if (inList) {
            const tag = listType === 'ol' ? 'ol' : 'ul';
            result.push(`<${tag} class="message-list">${listItems.join('')}</${tag}>`);
            listItems = [];
          }
          inList = true;
          listType = 'ol';
        }
        listItems.push(`<li>${numberedMatch[2]}</li>`);
        continue;
      }
      
      // Check for bullet list: * item or - item
      const bulletMatch = line.match(/^[\*\-\+]\s+(.+)$/);
      if (bulletMatch) {
        if (!inList || listType !== 'ul') {
          if (inList) {
            const tag = listType === 'ol' ? 'ol' : 'ul';
            result.push(`<${tag} class="message-list">${listItems.join('')}</${tag}>`);
            listItems = [];
          }
          inList = true;
          listType = 'ul';
        }
        listItems.push(`<li>${bulletMatch[1]}</li>`);
        continue;
      }
      
      // Not a list item - close list if open
      if (inList) {
        const tag = listType === 'ol' ? 'ol' : 'ul';
        result.push(`<${tag} class="message-list">${listItems.join('')}</${tag}>`);
        listItems = [];
        inList = false;
        listType = null;
      }
      
      // Process the line
      let processedLine = line;
      
      // Bold text: **text**
      processedLine = processedLine.replace(/\*\*([^*]+?)\*\*/g, '<strong>$1</strong>');
      
      // Headings
      if (processedLine.match(/^###\s+/)) {
        processedLine = processedLine.replace(/^###\s+(.+)$/, '<h3>$1</h3>');
        result.push(processedLine);
      } else if (processedLine.match(/^##\s+/)) {
        processedLine = processedLine.replace(/^##\s+(.+)$/, '<h2>$1</h2>');
        result.push(processedLine);
      } else if (processedLine.match(/^#\s+/)) {
        processedLine = processedLine.replace(/^#\s+(.+)$/, '<h2>$1</h2>');
        result.push(processedLine);
      } else {
        // Regular paragraph
        result.push(`<p>${processedLine}</p>`);
      }
    }
    
    // Close any open list
    if (inList) {
      const tag = listType === 'ol' ? 'ol' : 'ul';
      result.push(`<${tag} class="message-list">${listItems.join('')}</${tag}>`);
    }
    
    return result.join('');
  }
};

